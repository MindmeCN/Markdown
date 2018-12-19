
import {selectors as formSelectors} from '#/main/app/content/form/store/selectors'
import {selectors as mkpptSelectors} from '&/mindmecn/markdown-bundle/resources/mkppt/store/selectors'

const FORM_NAME = mkpptSelectors.STORE_NAME+'.mkpptForm'


const mkppt = (state) => formSelectors.data(formSelectors.form(state, FORM_NAME))


export const selectors = {
  FORM_NAME,
  mkppt
}
