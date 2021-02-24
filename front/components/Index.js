// imports 

import React, { Component } from 'react';
import { Platform, View, ScrollView, Text, StatusBar, SafeAreaView } from 'react-native';
import Carousel, { Pagination } from 'react-native-snap-carousel';
import {fetch as fetchPolyfill} from 'whatwg-fetch'
import { sliderWidth, itemWidth } from './SliderEntry.style';
import SliderEntry from './SliderEntry';
import styles, { colors } from './index.style';
import { scrollInterpolators, animatedStyles } from './utils/animations';
import axios from 'axios';
import { Collapse, CollapseHeader, CollapseBody } from "accordion-collapse-react-native";
import NavigationBar from 'react-native-navbar';

import { CollapsibleNavBarScrollView, CollapsibleNavBarState } from '@busfor/react-native-collapsible-navbar-scrollview'

const IS_ANDROID = Platform.OS === 'android';
const SLIDER_1_FIRST_ITEM = 1;
const styl = {
    container: {
      flex: 2,
    },
  };
  
  const rightButtonConfig = {
    title: 'Next',
    handler: () => alert('hello!'),
  };
  
  const titleConfig = {
    title: 'Back',
  };
  
 

// it is the main component of the application, and which calls on the other components 
export default class Index extends Component {

    constructor (props) {
        super(props);
        this.state = {
            slider1ActiveSlide: SLIDER_1_FIRST_ITEM,
            publicResources: null,
            nameList: [],
            count : 0
        };
       
    
    }
    doSomethingSuperWrong() {
      // this.state.count == 0
      this.setState({ count: this.state.count + 1 })
      this.setState({ count: this.state.count + 1 })
      this.setState({ count: this.state.count + 1 })
      console.log(this.state.count)
    }

    
     parseJSON(response) {
      return response.json()
    }

  //  componentDidMount () is used   to call the setState () method to change the state of the application 
    
    componentDidMount() {
         

      // fetching data from backend   at the port 8000 

      fetch('http://localhost:8001/api/get')
      .then(response => response.json())
      .then(data => {console.log(data);
       this.setState({
        
      nameList: data
      });
    console.log(this.state.nameList)
  }
  
  );

     /* axios.get("http://localhost:8001/api/get")
    
      .then((result) => {
        this.state.nameList = result.data;
        console.log(result.data)
        console.log(this.state.nameList)
        this.setState({
        
          nameList: result.data
        });
        
      },).catch(function(error) {
        console.log('There has been a problem with your fetch operation: ' + error.message);
         // ADD THIS THROW error
          throw error;
        });*/
     
     
    /*  axios.get('http://localhost:8001/api/public')
  .then(function (response) {
   
    console.log(response.data);
    this.state.nameList.setState({
        
      nameList: response.data
    });
  })
  .catch(function (error) {
    console.log(error);
  });
 */
    
  }


  //  we implement the carousel componement 
 
    _renderItem ({item, index}) {
        return <SliderEntry data={item} even={(index + 1) % 2 === 0} />;
    }

    _renderItemWithParallax ({item, index}, parallaxProps) {
        return (
            <SliderEntry
              data={item}
              even={(index + 1) % 2 === 0}
              parallax={true}
              parallaxProps={parallaxProps}
            />
        );
    }

    _renderLightItem ({item, index}) {
        return <SliderEntry data={item} even={false} />;
    }

    _renderDarkItem ({item, index}) {
        return <SliderEntry data={item} even={true} />;
    }

    momentumExample (number, title) {
        return (
        
            <View style={styles.exampleContainer}>
                    <View style={styl.container}>
     
    </View>
                <Text style={styles.title}>{`Example ${number}`}</Text>
                <Text style={styles.subtitle}>{title}</Text>
                <Carousel
                  data={ this.state.nameList}
                  renderItem={this._renderItem}
                  sliderWidth={sliderWidth}
                  itemWidth={itemWidth}
                  inactiveSlideScale={0.95}
                  inactiveSlideOpacity={1}
                  enableMomentum={true}
                  activeSlideAlignment={'start'}
                  containerCustomStyle={styles.slider}
                  contentContainerCustomStyle={styles.sliderContentContainer}
                  activeAnimationType={'spring'}
                  activeAnimationOptions={{
                      friction: 4,
                      tension: 40
                  }}
                />
            </View>
        );
    }



    render () {
        
        const example2 = this.momentumExample(2, 'Momentum | Left-aligned | Active animation');
        

        return (
            <SafeAreaView style={styles.safeArea}>
                <View style={styles.container}>
                    <StatusBar
                      translucent={true}
                      backgroundColor={'rgba(0, 0, 0, 0.3)'}
                      barStyle={'light-content'}
                    />
                   
                    <ScrollView
                      style={styles.scrollview}
                      scrollEventThrottle={200}
                      directionalLockEnabled={true}
                    >
                      
                        { example2 }
                        
                    </ScrollView>
                </View>
            </SafeAreaView>
        );
    }
}