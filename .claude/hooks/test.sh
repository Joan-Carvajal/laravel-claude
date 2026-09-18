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

if output=$(./vendor/bin/sail bin pest --bail --compact 2>&1); then
    msg="Pest pasó después de editar $relative_file."
else
    msg="Pest falló después de editar $relative_file:
$output"
fi

jq -nc --arg msg "$msg" '{hookSpecificOutput:{hookEventName:"PostToolUse",additionalContext:$msg}}'
exit 0
