export interface World {
    id: number;
    name: string;
    desc: string;
    created_at: Date;
    updated_at: Date;
    entities_count?: number;
}
