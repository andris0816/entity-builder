export interface Relationship {
    id: number;
    source: number;
    target: number;
    type: string;
    desc: string;
    createdAt: Date;
    updatedAt: Date;
}
