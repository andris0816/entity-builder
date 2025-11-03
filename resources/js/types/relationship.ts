import {Entity} from "./entity";

export interface Relationship {
    id: number;
    source: Entity;
    target: Entity;
    type: string;
    desc: string;
    createdAt: Date;
    updatedAt: Date;
}
