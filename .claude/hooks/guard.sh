#!/usr/bin/env bash
set -euo pipefail

input=$(cat)
tool=$(jq -r '.tool_name // empty' <<< "$input")
file=$(jq -r '.tool_input.file_path // empty' <<< "$input")
cmd=$(jq -r '.tool_input.command // empty' <<< "$input")

deny() {
    jq -nc --arg reason "$1" '{hookSpecificOutput:{hookEventName:"PreToolUse",permissionDecision:"deny",permissionDecisionReason:$reason}}'
    exit 0
}

if [[ "$tool" =~ ^(Read|Write|Edit|MultiEdit)$ ]]; then
    case "$file" in
        .env|./.env|*/.env|.env.*|./.env.*|*/.env.*)
            [[ "$file" == *".env.example" || "$file" == *".env.testing" ]] || deny "Acceso a archivos .env bloqueado. Usa .env.example o .env.testing."
            ;;
        *composer.lock|*package-lock.json)
            [[ "$tool" =~ ^(Write|Edit|MultiEdit)$ ]] && deny "No modifiques lock files directamente. Usa Composer o npm."
            ;;
    esac
fi

if [[ "$tool" == "Bash" ]]; then
    grep -qiE '(^|[;&|[:space:]])(rm[[:space:]]+-rf|git[[:space:]]+reset[[:space:]]+--hard|git[[:space:]]+push[[:space:]]+(-f|--force)|git[[:space:]]+clean[[:space:]]+-fd)' <<< "$cmd"         && deny "Comando destructivo bloqueado. Pide permiso explícito y explica el rollback."

    grep -qiE 'artisan[[:space:]]+(migrate:fresh|migrate:reset|db:wipe)' <<< "$cmd"         && deny "Artisan destructivo bloqueado. No lo ejecutes desde Claude Code."

    grep -qiE '^[[:space:]]*(drop[[:space:]]+(table|database)|truncate[[:space:]]+table)' <<< "$cmd"         && deny "SQL destructivo bloqueado. Requiere confirmación y plan de rollback."
fi

exit 0
