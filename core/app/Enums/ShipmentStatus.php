<?php

namespace App\Enums;

enum ShipmentStatus: string
{
    case New = 'new';
    case Accepted = 'accepted';
    case InTransit = 'in_transit';
    case Delivered = 'delivered';
    case Rejected = 'rejected';
    case Closed = 'closed';

    // Method to return a color for each status
    public function color(): string
    {
        return match ($this) {
            self::New => '#F7F1E5',          
            self::Accepted => '#59CE8F',     
            self::InTransit => '#F7DB6A',  
            self::Delivered => '#6887ff',  
            self::Rejected => '#FF1E00',       
            self::Closed => '#F96666',      
        };
    }

    // Method to return a string label for each status
    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Accepted => 'Accepted',
            self::InTransit => 'In Transit',
            self::Delivered => 'Delivered',
            self::Rejected => 'Rejected',
            self::Closed => 'Closed',
        };
    }
}
