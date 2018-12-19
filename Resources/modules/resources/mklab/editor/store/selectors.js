
import {selectors as formSelectors} from '#/main/app/content/form/store/selectors'
import {selectors as mklabSelectors} from '&/mindmecn/markdown-bundle/resources/mklab/store/selectors'

const FORM_NAME = mklabSelectors.STORE_NAME+'.mklabForm'


const mklab = (state) => formSelectors.data(formSelectors.form(state, FORM_NAME))


export const selectors = {
  FORM_NAME,
  mklab
}
