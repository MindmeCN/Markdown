
import React, {Component} from 'react'
import ReactDOM from 'react-dom';
import ReactTable from "react-table"
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'


import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'


class MkLabReportComponent extends React.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return  (
                <div>
                 <h2>Any content 3</h2>
                </div>
                )
    }
}

MkLabReportComponent.propTypes = {
    content: T.string.isRequired
}

const MkLabReport = connect(
        state => ({
                content: selectors.mklab.content,
            })
)(MkLabReportComponent)

export {
MkLabReport
        }


