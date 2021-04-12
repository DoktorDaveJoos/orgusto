import _ from 'lodash';

export default function parseObject(object: any): any {
  return object instanceof Object ? _.cloneDeep(object) : JSON.parse(object);
}
