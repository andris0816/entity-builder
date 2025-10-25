export interface Relationship {
    id: number;
    entity_from: number;
    entity_to: number;
    type: string;
    desc: string;
    created_at: Date;
    updated_at: Date;
}
