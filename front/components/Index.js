// imports

import React , { Component }  from "react";
import { Text, TouchableOpacity, View ,Animated , StyleSheet} from "react-native";
//import Swiper from "react-native-web-swiper";

import { Platform, ScrollView, StatusBar, SafeAreaView ,Pictures ,Dimensions,Image} from 'react-native';
import Carousel, { Pagination } from 'react-native-snap-carousel';
import { sliderWidth, itemWidth } from './SliderEntry.style';
import SliderEntry from './SliderEntry';
import styles, { colors } from './index.style';





const { width: SCREEN_WIDTH } = Dimensions.get('screen')
const SLIDER_1_FIRST_ITEM = 1;
const styl = {
    container: {
      flex: 2,
    },
  };
  
 
const HEADER_EXPANDED_HEIGHT = 100
const HEADER_COLLAPSED_HEIGHT = 60

const s = StyleSheet.create({

  scrollContainer: {
    padding: 16
  }, 
 
})


// it is the main component of the application, and which calls on the other components 

export default class Index extends Component {

    constructor (props) {
        super(props);
        this.state = {
            slider1ActiveSlide: SLIDER_1_FIRST_ITEM,
            publicResources: null,
            nameList: [],
            count : 0,
           
      scrollY: new Animated.Value(0)
    
        };
       
    
    }
    
    //  componentDidMount () is used   to call the setState () method to change the state of the application 
    
    componentDidMount() {
     
          // fetching data from backend   at the port 8000 
     
      fetch("http://localhost:8000/api/get")
      .then(res => res.json())
      .then((result) => {
        
        console.log(result)
        console.log(this.state.nameList)
        this.setState({
        
          nameList: result
        });
        
      },)
      console.log(this.state.nameList)
     
      
 
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
       const headerHeight = this.state.scrollY.interpolate({
      inputRange: [0, HEADER_EXPANDED_HEIGHT-HEADER_COLLAPSED_HEIGHT],
      outputRange: [HEADER_EXPANDED_HEIGHT, HEADER_COLLAPSED_HEIGHT],
      extrapolate: 'clamp'
    })
        return (
        
            <View style={styles.exampleContainer}>
                    <View style={styl.container}>
    
     <View style={styles.container}>
        <Animated.View style={{height: headerHeight, width: SCREEN_WIDTH, position: 'absolute', top: 0, left: 0}}/>
          <ScrollView
            contentContainerStyle={s.scrollContainer}
            onScroll={Animated.event(
              [{ nativeEvent: {
                   contentOffset: {
                     y: this.state.scrollY
                   }
                 }
              }])}
            scrollEventThrottle={16}>
       
          </ScrollView>
      </View>
      <SafeAreaView>
      <View>
        <View
          style={{
            top: 0,
            left: 0,
            right: 0,
            height: headerHeight,
            backgroundColor: 'lightblue',
          }}>
          <Text
            style={{
              opacity: 'opacity',
              fontSize: 30,
            }}>
            
          </Text>
          <Image
            style={{
              height: 50,
              width: 50,
              borderRadius: 10,
              transform: [{translateX: 1}],
            }}
            source={{
              uri:
                'https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-back-512.png',
            }}
          />
        </View>
        <ScrollView
          contentInsetAdjustmentBehavior="automatic"
          style={[styles.scrollView]}>
         
       
            
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
                
           
             </ScrollView>
      </View>
      </SafeAreaView>
    </View>
    </View>
        );
    }


    render () {
       // const example1 = this.mainExample(1, 'Default layout | Loop | Autoplay | Parallax | Scale | Opacity | Pagination with tappable dots');
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

  const HeaderExample = (opacity) => {
  return (
        <View style={{flex: 1, alignItems: 'center'}}>
        <Animated.View style={{
          opacity
        }}>
          <Text>this text will disappear when scrolling</Text>
        </Animated.View>
        

        <View style={{flexDirection:'row', marginTop: 15}}>
        
          
        </View>
        
      </View>   
  )
}


