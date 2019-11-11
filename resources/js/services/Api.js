/* eslint-disable */
import axios from 'axios'
import Config from "../includes/Config";


export default () => {
   return axios.create({
      baseURL: `${Config.getURL()}`
   })
}