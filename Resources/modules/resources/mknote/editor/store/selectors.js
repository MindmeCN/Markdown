
import {selectors as formSelectors} from '#/main/app/content/form/store/selectors'
import {selectors as mknoteSelectors} from '&/mindmecn/markdown-bundle/resources/mknote/store/selectors'

const FORM_NAME = mknoteSelectors.STORE_NAME+'.mknoteForm'


const mknote = (state) => formSelectors.data(formSelectors.form(state, FORM_NAME))


export const selectors = {
  FORM_NAME,
  mknote
}
