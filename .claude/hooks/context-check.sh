#!/usr/bin/env bash
set -euo pipefail

input=$(cat)
transcript_path=$(jq -r '.transcript_path // empty' <<< "$input")

[[ -z "$transcript_path" || ! -f "$transcript_path" ]] && exit 0

bytes=$(wc -c < "$transcript_path" | tr -d ' ')
threshold=1000000

if [[ "$bytes" =~ ^[0-9]+$ && "$bytes" -gt "$threshold" ]]; then
    msg="La sesión ya tiene un transcript grande. Antes de una tarea amplia, ejecuta /compact con un resumen explícito."
    jq -nc --arg msg "$msg" '{hookSpecificOutput:{hookEventName:"UserPromptSubmit",additionalContext:$msg}}'
fi

exit 0
