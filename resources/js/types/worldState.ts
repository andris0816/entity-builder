import {Entity} from "./entity";
import {Relationship} from "./relationship";
import {ViewPort} from "./ViewPort";

export type SelectedItem =
    | {type: 'entity'; id: number}
    | {type: 'relationship'; id: number}
    | null

export interface WorldState {
    worldId: string;
    entities: Entity[];
    relationships: Relationship[];
    selectedItem: SelectedItem;
    isLoading: boolean;
}
