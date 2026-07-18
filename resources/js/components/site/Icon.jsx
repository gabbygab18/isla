import {
    ArrowRight,
    Calculator,
    Calendar,
    CalendarHeart,
    Check,
    ChevronDown,
    Clipboard,
    Clock,
    Globe,
    HardHat,
    Headset,
    Mail,
    MapPin,
    Megaphone,
    MessageCircle,
    Phone,
    Receipt,
    Shield,
    Sparkles,
    Star,
    Target,
    Users,
    X,
} from 'lucide-react';

/**
 * Maps the DB-stored icon keys (the old SVG-sprite ids, e.g. "i-shield")
 * onto lucide-react icons, so admin-managed content keeps working.
 */
const MAP = {
    'i-arrow': ArrowRight,
    'i-calendar': Calendar,
    'i-calendar-heart': CalendarHeart,
    'i-calculator': Calculator,
    'i-check': Check,
    'i-chevron': ChevronDown,
    'i-clipboard': Clipboard,
    'i-clock': Clock,
    'i-globe': Globe,
    'i-hardhat': HardHat,
    'i-headset': Headset,
    'i-mail': Mail,
    'i-megaphone': Megaphone,
    'i-message': MessageCircle,
    'i-phone': Phone,
    'i-pin': MapPin,
    'i-receipt': Receipt,
    'i-shield': Shield,
    'i-star': Star,
    'i-sparkles': Sparkles,
    'i-target': Target,
    'i-users': Users,
    'i-x': X,
};

export default function Icon({ name, className = 'h-5 w-5', strokeWidth = 2 }) {
    const Comp = MAP[name] ?? Sparkles;
    return <Comp className={className} strokeWidth={strokeWidth} />;
}
