import {InvalidIDError} from "../errors/ValidationErrors";

export default function checkId(id: number): boolean {
    if (id < 0 || id === undefined || id === null) throw InvalidIDError.of(id)
    else return true;
}
