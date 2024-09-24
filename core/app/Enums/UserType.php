<?php

namespace App\Enums;

enum UserType: string
{
    case Admin = 'admin';
    case Customer = 'customer';
    case CompanyUser = 'company_user';
}
