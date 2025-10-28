export interface Entity {
    id: number;
    name: string;
    desc: string;
    type: string;
    createdAt: Date;
    updatedAt: Date;
    x?: number;
    y?: number;
}
