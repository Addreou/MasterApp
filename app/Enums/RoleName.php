<?php

namespace App\Enums;

enum RoleName: string
{
    case DEVELOPER  = 'Desarrollador';
    case ADMIN      = 'Administrador';
    case Primary    = 'Primario';
    case Secondary  = 'Secundario';
    case Tertiary   = 'Terciario';
}
