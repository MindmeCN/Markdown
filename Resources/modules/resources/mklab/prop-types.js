import {PropTypes as T} from 'prop-types'

const Mklab = {
  propTypes: {
    id: T.number,
    content: T.string,
    htmlcontent: T.string,
    meta: T.shape({
      version: T.number
    })
  }
}

export {
  Mklab
}