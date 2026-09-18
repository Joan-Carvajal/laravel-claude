---
paths:
  - "app/Models/**/*.php"
---

# Eloquent Model Rules

- Revisa primero si existe `App\Models\Base\{Model}`.
- Sigue el patrón local antes de añadir traits o casts nuevos.
- Define relaciones Eloquent con return types.
- Usa `casts(): array` si el proyecto ya usa ese patrón.
- Evita accessors que disparen queries.
- Usa eager loading cuando una relación se lea en listados.
