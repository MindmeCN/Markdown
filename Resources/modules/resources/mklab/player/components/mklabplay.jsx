
import React, {Component} from 'react'
import ReactDOM from 'react-dom';
import ReactTable from "react-table"
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'


import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'

import {MkLabReport} from '&/mindmecn/markdown-bundle/resources/mklab/player/components/mklabreport'
import {MkLabPractice} from '&/mindmecn/markdown-bundle/resources/mklab/player/components/mklabpractice'
import {MkLabStudy} from '&/mindmecn/markdown-bundle/resources/mklab/player/components/mklabstudy'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'
import {Mklab as MklabTypes} from '&/mindmecn/markdown-bundle/resources/mklab/prop-types'


class MkLabPlayComponent extends React.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return  (
                <div>
                    <Tabs>
                        <TabList>
                            <Tab>实验学习</Tab>
                            <Tab>实验报告</Tab>
                        </TabList>    
                        <TabPanel>
                             <MkLabPractice/>
                        </TabPanel>
                        <TabPanel>
                            <MkLabReport/>
                        </TabPanel>
                    </Tabs>
                </div>
                )
    }
}

MkLabPlayComponent.propTypes = {
    workspace: T.object,
    mklab: T.shape(
    MklabTypes.propTypes
  ).isRequired,
} 
const MkLabPlay = connect(
        state => ({
             mklab: selectors.mklab(state)
            })
)(MkLabPlayComponent)

export {
MkLabPlay
        }


