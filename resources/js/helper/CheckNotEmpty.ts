import {NotEmptyError} from '../errors/ValidationErrors';

export default function checkNotEmpty(value: string): boolean {
  if (value.length > 0) return true;
  else throw NotEmptyError.of(value);
}
