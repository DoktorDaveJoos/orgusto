import _ from 'lodash';
import {InvalidIDError, NotEmptyError} from "../exceptions/Exceptions";

export function parseObject(object: any): any {
    return object instanceof Object ? _.cloneDeep(object) : JSON.parse(object);
}

export function checkNotEmpty(value: string): boolean {
    if (value.length > 0) return true
    else throw NotEmptyError.of(value);
}

export function checkId(id: number): boolean {
    if (id < 0 || id === undefined || id === null) throw InvalidIDError.of(id)
    else return true;
}
