import {Entity} from "./entity";
import {Relationship} from "./relationship";
import {ViewPort} from "./ViewPort";

export interface WorldState {
    worldId: string;
    entities: Entity[];
    relationships: Relationship[];
    selectedEntityId: number;
    isLoading: boolean;
    viewport: ViewPort;
    dragInProgress: boolean
}
