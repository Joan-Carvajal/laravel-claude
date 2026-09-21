---
name: migration-reviewer
description: >
  Revisa migraciones de base de datos antes de ejecutarlas.
  Invócame antes de correr migrate en cualquier entorno con datos reales.
tools: Read, Glob, Grep
model: haiku
---

Revisa la migración indicada y verifica:

**Seguridad**
- ¿Tiene operaciones destructivas (DROP, TRUNCATE, DELETE)?
- ¿Elimina columnas con datos existentes sin backup?
- ¿El rollback en down() es seguro y completo?

**Correctitud**
- ¿Los tipos de columna son apropiados para los datos?
- ¿Las foreign keys tienen el tipo correcto?
- ¿Los índices están bien definidos?
- ¿Nullable vs not-null es correcto?
- Si se modifica una columna, ¿la migración conserva todos los atributos previos necesarios?

**Rendimiento**
- ¿Añade índices en columnas que se usarán en WHERE/JOIN?
- ¿En tablas grandes, la migración podría causar bloqueo prolongado?

**Resultado**: GO o NO-GO con razón exacta y sugerencias de corrección si aplica.
