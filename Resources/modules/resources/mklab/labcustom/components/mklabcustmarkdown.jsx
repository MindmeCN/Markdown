
import React, {Component} from 'react'
import ReactDOM from 'react-dom';

import $ from 'jquery'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'
import ReactMarkdown from 'react-markdown'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'


const input = '# This is a header\n\n```js \n\nvar React = require(\'react\');\n\nvar Markdown = require(\'react-markdown\');\n\n```'

class MkLabMarkdownComponent extends React.Component{
 constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="ag-theme-fresh">
              <ReactMarkdown source={input} />
            </div>
            );
    }
}

  
MkLabMarkdownComponent.propTypes = {
} 

const MkLabMarkdown = connect(
   state => ({
    mklab: selectors.mklab
  })
)(MkLabMarkdownComponent)

export {
  MkLabMarkdown
}


