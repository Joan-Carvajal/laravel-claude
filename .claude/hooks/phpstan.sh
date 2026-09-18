#!/usr/bin/env bash
set -euo pipefail

input=$(cat)
file=$(jq -r '.tool_input.file_path // empty' <<< "$input")
project_dir=${CLAUDE_PROJECT_DIR:-$(jq -r '.cwd // empty' <<< "$input")}

[[ -z "$file" || "$file" != *.php || -z "$project_dir" ]] && exit 0

case "$file" in
    "$project_dir"/*)
        host_file="$file"
        relative_file="${file#"$project_dir"/}"
        ;;
    /*)
        exit 0
        ;;
    *)
        host_file="$project_dir/$file"
        relative_file="$file"
        ;;
esac

case "$relative_file" in
    ..|../*|*/../*) exit 0 ;;
esac

[[ ! -f "$host_file" || ! -x "$project_dir/vendor/bin/sail" ]] && exit 0

cd "$project_dir"
output=$(./vendor/bin/sail bin phpstan analyse "$relative_file" --no-progress 2>&1) || {
    jq -nc --arg msg "PHPStan encontró errores en $relative_file:
$output" '{hookSpecificOutput:{hookEventName:"PostToolUse",additionalContext:$msg}}'
    exit 0
}

exit 0
