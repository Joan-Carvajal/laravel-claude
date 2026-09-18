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

before_hash=$(sha1sum "$host_file" | cut -d ' ' -f 1)

cd "$project_dir"
./vendor/bin/sail bin pint "$relative_file" --quiet >/dev/null 2>&1 || true

after_hash=$(sha1sum "$host_file" | cut -d ' ' -f 1)

if [[ "$before_hash" != "$after_hash" ]]; then
    jq -nc --arg msg "Pint formateó $relative_file. Relee el archivo antes de seguir; el contenido en disco ya cambió." '{hookSpecificOutput:{hookEventName:"PostToolUse",additionalContext:$msg}}'
fi

exit 0
