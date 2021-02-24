import React, { Component } from 'react';
import { View, Text, Image, TouchableOpacity ,StyleSheet,Alert } from 'react-native';
import PropTypes from 'prop-types';
import { ParallaxImage } from 'react-native-snap-carousel';
import styles from './SliderEntry.style';
import {Button} from 'react-native';
import Icon from 'react-native-vector-icons/FontAwesome5';
import { Stack } from "react-native-spacing-system";






const Separator = () => (
  <View style={sty.separator} />
);
const sty = StyleSheet.create({
 /* container: {
    flex: 1,
    justifyContent: 'center',
    marginHorizontal: 16,
  },
  title: {
    textAlign: 'center',
    marginVertical: 8,
  },
  fixToText: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },*/
  separator: {
    marginVertical: 8,
    borderBottomColor: '#737373',
    borderBottomWidth: StyleSheet.hairlineWidth,
  },
});

export default class SliderEntry extends Component {

    static propTypes = {
        data: PropTypes.object.isRequired,
        even: PropTypes.bool,
        parallax: PropTypes.bool,
        parallaxProps: PropTypes.object
    };

    get image () {
        const { data: { illustration }, parallax, parallaxProps, even } = this.props;

        return parallax ? (
            <ParallaxImage
              source={{ uri: illustration }}
              containerStyle={[styles.imageContainer, even ? styles.imageContainerEven : {}]}
              style={styles.image}
              parallaxFactor={0.35}
              showSpinner={true}
              spinnerColor={even ? 'rgba(255, 255, 255, 0.4)' : 'rgba(0, 0, 0, 0.25)'}
              {...parallaxProps}
            />
        ) : (
            <Image
              source={{ uri: illustration }}
              style={styles.image}
            />
        );
    }

    render () {
        const { data: { firstname, title}, even } = this.props;

        const uppercaseTitle = firstname ? (
            <Text
              style={[styles.firstname, even ? styles.titleEven : {}]}
              numberOfLines={2}
            >
             
            </Text>
            
        ) : false;

        return (
            <TouchableOpacity
              activeOpacity={1}
              style={styles.slideInnerContainer}
              onPress={() => { alert(`You've clicked '${firstname}'`); }}
              >
                <View style={styles.shadow} />
                <View style={[styles.imageContainer, even ? styles.imageContainerEven : {}]}>
                <View  style={[styles.textContainer, even ? styles.textContainerEven : {}]}> 
              <View>
            <Icon name="user" size={30} color="#900" />  
            <Stack size={16} />
            <Text> <b>Firstname : </b> { firstname }</Text>
            <Text> <b>Last name : </b> { firstname }</Text>

            <Text> <b>formation :  </b> I am in the 3rd year of the computer engineering cycle  </Text>

             <Text> Description :  HI </Text>
            <Stack size={16} />
             <View style={{
      flex: 1,
        flexDirection: 'column',
        justifyContent: 'space-between',
    }}>   
    
               <View  >     
                        <Button 
        title="take lessons with this teach'r "
        onPress={() => Alert.alert('take lessons with this teachr')}
        
      />
      </View>
 <Stack size={16} />
      <View style={{
      flex: 0.1,
        
    }}>
       <Button
        title="remove this teachr from my favorites "
        onPress={() => Alert.alert('remove this teachr from my favorites ')}
  
      />
      </View>
      </View>
            <Text></Text>
                  </View> 
               </View>
                    
                </View>
                <View style={[styles.textContainer, even ? styles.textContainerEven : {}]}>
                    { uppercaseTitle }
                    <Text
                      style={[styles.subtitle, even ? styles.subtitleEven : {}]}
                      numberOfLines={2}
                    >
              
                    </Text>
                  
                </View>
            </TouchableOpacity>
        );
    }


    
}


