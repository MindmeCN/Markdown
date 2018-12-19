
import React, {Component} from 'react'
import ReactDOM from 'react-dom';
import $ from 'jquery'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'

import Stepper from 'react-stepper-horizontal';

class MkLabCustStepsComponent extends React.Component{
   constructor(props){
    super(props);
  }

componentDidMount(){     
}

    render() {
        return (  
               <Stepper steps={ [{title: 'Step One'}, {title: 'Step Two'}, {title: 'Step Three'}, {title: 'Step Four'},{title: 'Step Five'}] } activeStep={ 1 } />
                ); 
     } 
 }
   
MkLabCustStepsComponent.propTypes = {
};


const MkLabCustSteps = connect(
   state => ({
    defaultmode: selectors.mklab.defaultmode,
    mklab: selectors.mklab
  })
)(MkLabCustStepsComponent)

export {
  MkLabCustSteps
}


