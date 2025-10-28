export interface Relationship {
    id: number;
    entityFrom: number;
    entityTo: number;
    type: string;
    desc: string;
    createdAt: Date;
    updatedAt: Date;
}
