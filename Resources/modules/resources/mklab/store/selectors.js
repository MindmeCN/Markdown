import {createSelector} from 'reselect'

const STORE_NAME = 'resource'

const resource = (state) => state[STORE_NAME]

const mklab = createSelector(
  [resource],
  (resource) => resource.mklab
)


export const selectors = {
  STORE_NAME,
  resource,
  mklab
}
