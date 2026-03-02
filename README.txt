Ayapanario2 (proyecto minimalista)

Requisitos
- PHP 7.4+ (recomendado 8.x)
- MySQL/MariaDB
- Base de datos con tabla `diccionario` y tabla `usuarios`

Config
- Edita _includes/config.php o define variables de entorno:
  DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS

Uso
1) Importa tu SQL (diccionario2.0.sql) y asegúrate que existe `usuarios`.
2) Abre /login.php
3) Inicia sesión y consulta el diccionario en /buscar.php

Notas
- La búsqueda usa LIKE (tolerante a ʔ/' y diacríticos aproximados). Para FULLTEXT:
  ALTER TABLE diccionario ADD FULLTEXT ft_dicc (lema, ortografia, definicion, ejemplos);
  Luego cambia AYA_ENABLE_FULLTEXT a true en _includes/diccionario.php (si tu motor lo soporta).
