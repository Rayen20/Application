import { StatusBar } from 'expo-status-bar';
import React from 'react';
import { StyleSheet, Text, View } from 'react-native';
import Index from './components/Index';
import NavigationBar from 'react-native-navbar';

const rightButtonConfig = {
  title: 'Next',
  handler: () => alert('hello!'),
};

const titleConfig = {
  title: 'Hello, world',
};
export default function App() {
  return (
    <View >
    
      <Index/>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
