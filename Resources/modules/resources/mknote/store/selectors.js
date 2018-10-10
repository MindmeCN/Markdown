import {createSelector} from 'reselect'

const STORE_NAME = 'resource'

const resource = (state) => state[STORE_NAME]

const mknote = createSelector(
  [resource],
  (resource) => resource.mknote
)


export const selectors = {
  STORE_NAME,
  resource,
  mknote
}
