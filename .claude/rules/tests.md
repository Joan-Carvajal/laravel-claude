---
paths:
  - "tests/**/*.php"
  - "app/Http/Controllers/**/*.php"
  - "app/Actions/**/*.php"
---

# Testing Rules (Pest v4)

- Feature tests para endpoints y flujos HTTP.
- Unit tests para lógica aislada.
- Usa factories; no hardcodees IDs.
- Prefiere assertions expresivas como `assertSuccessful()`, `assertForbidden()` y `assertNotFound()`.
- Ejecuta el test afectado primero.
- No cambies assertions para ocultar un bug.
