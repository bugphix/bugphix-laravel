const isObjectEmpty = (obj) => {
  return Object.entries(obj).length === 0 && obj.constructor === Object
}

const serialize = (obj) => {
  return `?${Object.keys(obj).reduce((a, k) => { a.push(`${k}=${encodeURIComponent(obj[k])}`); return a; }, []).join('&')}`;
}

const renderEventHtml = (_time) => {

  if(typeof _time === 'string') return _time;

  const {date, formatted, ago} = _time;
  let eventTime = formatted || date || '';
  if(!eventTime) return;
  return `<span class="timestamp">${ago} <span class="event-time">${eventTime}</span></span>`;
}

function serializeParams(obj) {
  return `?${Object.keys(obj).reduce((a, k) => { a.push(`${k}=${encodeURIComponent(obj[k])}`); return a; }, []).join('&')}`;
}

function nFormat(num, digits=2) {
  var si = [
    { value: 1, symbol: "" },
    { value: 1E3, symbol: "k" },
    { value: 1E6, symbol: "M" },
    { value: 1E9, symbol: "G" },
    { value: 1E12, symbol: "T" },
    { value: 1E15, symbol: "P" },
    { value: 1E18, symbol: "E" }
  ];
  var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
  var i;
  for (i = si.length - 1; i > 0; i--) {
    if (num >= si[i].value) {
      break;
    }
  }
  return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
}

export {
  isObjectEmpty,
  serialize,
  renderEventHtml,
  serializeParams,
  nFormat,
};
