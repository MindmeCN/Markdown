import {createSelector} from 'reselect'

const STORE_NAME = 'resource'

const resource = (state) => state[STORE_NAME]

const mkppt = createSelector(
  [resource],
  (resource) => resource.mkppt
)


export const selectors = {
  STORE_NAME,
  resource,
  mkppt
}
