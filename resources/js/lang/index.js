// resources/js/lang/index.js
import en from './en.json'
import es from './es.json'

let currentLang = 'en'
const messages = { en, es }  //objeto con las dos traducciones

export function setLang(lang) {
  if (messages[lang]) currentLang = lang
}

export function t(key) {
  const parts = key.split('.')
  let val = messages[currentLang]
  for (const part of parts) {
    if (val) val = val[part]
  }
  return val || key
}
