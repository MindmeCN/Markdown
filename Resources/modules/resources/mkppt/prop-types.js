import {PropTypes as T} from 'prop-types'

const Mkppt = {
  propTypes: {
    id: T.number,
    content: T.string,
    meta: T.shape({
      version: T.number
    })
  }
}

export {
  Mkppt
}