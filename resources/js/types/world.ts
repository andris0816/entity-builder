export interface World {
    id: number;
    name: string;
    desc: string;
    createdAt: Date;
    updatedAt: Date;
    entitiesCount?: number;
}
