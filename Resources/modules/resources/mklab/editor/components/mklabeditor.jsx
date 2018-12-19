
import React, {Component} from 'react'
import ReactDOM from 'react-dom';
import ReactTable from "react-table"
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'


import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'

import {MkLabCustEdit} from '&/mindmecn/markdown-bundle/resources/mklab/labcustom/components/mklabcustedit'
import {MkLabCustSummary} from '&/mindmecn/markdown-bundle/resources/mklab/labcustom/components/mklabcustsummary'
import {MkLabCustFlow} from '&/mindmecn/markdown-bundle/resources/mklab/labcustom/components/mklabcustflow'
import {selectors} from '&/mindmecn/markdown-bundle/resources/mklab/store'
import {MkEdit} from '&/mindmecn/markdown-bundle/resources/mklab/editor/components/mkedit'


class MkLabEditorComponent extends React.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return  (
                <div>
                    <Tabs>
                        <TabList>
                            <Tab>自定义实验</Tab>
                            <Tab>代码转换</Tab>
                            <Tab>命令调试</Tab>
                            <Tab>实验流程定制</Tab>
                        </TabList>   
                          <TabPanel>
                             <MkLabCustEdit/>
                        </TabPanel>
                        <TabPanel>
                           <MkEdit/>
                        </TabPanel>
                         <TabPanel>
                              <MkLabCustSummary/>
                        </TabPanel>
                        <TabPanel>
                              <MkLabCustFlow/>
                        </TabPanel>
                    </Tabs>
                </div>
                )
    }
}

MkLabEditorComponent.propTypes = {
}

const MkLabEditor = connect(
        state => ({
                content: selectors.mklab.content,
            })
)(MkLabEditorComponent)

export {
MkLabEditor
}


