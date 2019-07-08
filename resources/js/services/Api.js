/* eslint-disable */
import axios from 'axios'
export default () => {
   return axios.create({
      //  baseURL:  `http://192.168.0.22/stock2.0/public/`
       baseURL:  `http://192.168.0.232/stock2.0/public/`
      //  baseURL:  `http://localhost/stock2.0/public/`
   }) 
}