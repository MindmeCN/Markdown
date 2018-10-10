import {PropTypes as T} from 'prop-types'

const Mktemplate = {
  propTypes: {
    id: T.number,
    content: T.string,
    meta: T.shape({
      version: T.number
    })
  }
}

export {
  Mktemplate
}