
import React, {Component} from 'react'
import ReactDOM from 'react-dom'
import $ from 'jquery'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'
import Select from 'react-select'
import {MkLabCustSteps} from '&/mindmecn/markdown-bundle/resources/mklab/labcustom/components/mklabcuststeps'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'

const options = [
            {value: 'editor', label: '编辑'},
            {value: 'console', label: '控制台'},
            {value: 'other', label: '其它'}
        ]



class MkLabCustSummaryComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedOption: null,
        }
        this.handleChange = (selectedOption) => {
        this.setState({selectedOption});
        console.log(`Option selected:`, selectedOption);
    }
    }
    render() {
        const selectedOption = this.state
        return (
            <div>
             <div id="__react-content" className={classes('mklab-steps')} style={{width:'60%',hight:'20px',float:'left'}}>
                  <MkLabCustSteps/>
             </div>
 
            </div>
 )
    }
}

MkLabCustSummaryComponent.propTypes = {
};

const MkLabCustSummary = connect(
        state => ({
                defaultmode: selectors.mklab.defaultmode,
                mklab: selectors.mklab
            })
)(MkLabCustSummaryComponent)

export {
MkLabCustSummary
        }


