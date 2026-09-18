---
name: project-qa
description: Ejecuta e interpreta el pipeline de calidad de este proyecto Laravel con Sail. Úsala cuando el usuario pida QA, verificación, tests, análisis estático o saber si una rama está lista para revisión.
---

# Project QA

## Objetivo
Verificar el cambio actual con la señal útil más pequeña primero, y ampliar solo cuando haga falta.

## Pasos
1. Revisa `git status --short` e identifica las zonas tocadas.
2. Ejecuta el test Pest afectado cuando sea evidente.
3. Ejecuta `sail bin pint --dirty` antes de terminar.
4. Si el cambio toca varias capas, ejecuta `sail composer qa`.
5. Informa de comandos ejecutados, fallos y riesgo restante.

## Reglas
- Usa Sail para PHP, Composer, Artisan, Pint, PHPStan y Pest.
- No cambies assertions solo para hacer pasar tests.
- No ejecutes comandos Artisan destructivos.
- Ejecuta los tests afectados antes de decir que la tarea está lista.
