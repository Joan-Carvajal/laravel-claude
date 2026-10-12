# Guía de seguridad de claude-tasks

Aplicación Laravel 13 con Eloquent y Blade que se ejecuta con Laravel Sail. Revisa los cambios con esta lista, además de la tuya.

## Entrada de usuario y asignación masiva

- Toda petición que crea o modifica datos se valida con un Form Request, y el código usa `$request->validated()` o `$request->safe()`. Márcalo si se usan `$request->all()` o `$request->input()` sin validar.
- Los modelos declaran sus campos asignables con `#[Fillable([...])]`. Márcalo si un modelo usa `#[Unguarded]`, `$guarded = []` o `Model::unguard()`, o si se pasa la petición entera a `create()`, `fill()` o `update()`.

## Autorización

- Toda acción sobre un recurso que pertenece a un usuario comprueba que el usuario autenticado puede hacerla, con una policy y `Gate::authorize()`, el middleware `can` o el método `authorize()` de un Form Request.
- Un endpoint que busca un modelo por su ID y lo devuelve, lo modifica o lo borra sin esa comprobación es una referencia directa insegura a objetos (IDOR).
- Estar autenticado no basta para las rutas de administración: además, comprueban un permiso concreto.

## Base de datos

- Las consultas usan Eloquent o el query builder con bindings. `DB::raw()`, `DB::select()`, `whereRaw()`, `selectRaw()` y `orderByRaw()` solo son aceptables con los valores pasados como bindings, nunca interpolados en el SQL.
- Los nombres de columna, de orden o de relación que llegan de la petición se comparan con una lista cerrada antes de usarlos en una consulta.

## Datos sensibles

- Las respuestas nunca incluyen contraseñas, tokens ni secretos. Los modelos ocultan esos campos con `#[Hidden([...])]`, y las APIs devuelven API Resources con los campos escritos uno a uno.
- Los secretos se leen con `config()`, que los toma del `.env`. Márcalo si aparece una clave, un token o una contraseña escritos en el código, en un test o en un seeder.
- Los logs no guardan contraseñas, tokens ni datos personales completos.

## Peticiones, sesiones y vistas

- Las rutas de `routes/web.php` que cambian datos usan POST, PUT, PATCH o DELETE y mantienen la protección contra CSRF. Márcalo si se añade una ruta a las excepciones de `preventRequestForgery` sin justificarlo.
- El login, el registro y el restablecimiento de contraseña llevan limitación de peticiones con el middleware `throttle`.
- Blade escapa la salida con `{{ }}`. Márcalo si se usa `{!! !!}` con contenido que puede venir del usuario.

## Configuración

- Ningún cambio fuerza `APP_DEBUG` a verdadero ni enseña trazas de error al usuario fuera del entorno local.