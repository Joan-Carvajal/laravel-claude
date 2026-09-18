---
description: Revisa el diff actual antes de cerrar una tarea
allowed-tools: Bash(git diff:*), Bash(git status:*)
---

## Contexto
- Estado: !`git status --short`
- Diff: !`git diff -- . ':!composer.lock' ':!package-lock.json'`

## Tarea
Revisa el diff buscando:
1. bugs probables,
2. tests ausentes,
3. cambios fuera de alcance,
4. riesgos de seguridad.

Devuelve hallazgos con archivo y razón. Si no ves problemas, dilo explícitamente.
