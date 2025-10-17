import { formatDistanceToNow } from 'date-fns';
import {enUS} from "date-fns/locale";

export function timeAgo(date: Date | string | number, locale = enUS): string {
    return formatDistanceToNow(new Date(date), { addSuffix: true, locale });
}
