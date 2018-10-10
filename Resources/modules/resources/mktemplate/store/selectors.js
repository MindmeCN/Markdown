import {createSelector} from 'reselect'

const STORE_NAME = 'resource'

const resource = (state) => state[STORE_NAME]

const mktemplate = createSelector(
  [resource],
  (resource) => resource.mktemplate
)


export const selectors = {
  STORE_NAME,
  resource,
  mktemplate
}
