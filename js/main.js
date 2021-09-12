const formElement = document.getElementById('form');
const inputElement = document.getElementById('input');
const loadingElement = document.getElementById('loading');
const resultElement = document.getElementById('result');
const errorElement = document.getElementById('error');

function populateList(list, items) {
  let listItem, title, description, url;
  for (let i = 0; i < items.length; i++) {
    listItem = document.createElement('div');
    listItem.classList.add('card');
    title = document.createElement('h2');
    title.append(document.createTextNode(items[i].title));
    description = document.createElement('p');
    description.append(document.createTextNode(items[i].description));
    url = document.createElement('small');
    url.append(document.createTextNode(items[i].url));
    listItem.append(title);
    listItem.append(description);
    listItem.append(url);
    list.appendChild(listItem);
  }
}

formElement.addEventListener('submit', e => {
  e.preventDefault();
  loadingElement.style.display = 'block';
  resultElement.style.display = 'none';
  errorElement.style.display = 'none';
  const formData = new FormData(formElement);
  fetch('./check', {
    method: 'POST',
    body: formData,
  })
  .then(response => response.json())
  .then(result => {
    loadingElement.style.display = 'none';
    resultElement.style.display = 'block';
    resultElement.innerHTML = '';
    if (result.length > 0) {
      populateList(resultElement, result);
    } else {
      const listItem = document.createElement('div');
      listItem.classList.add('card');
      listItem.append(document.createTextNode('No entries found'));
      resultElement.appendChild(listItem);
    }
  })
  .catch(error => {
    loadingElement.style.display = 'none';
    resultElement.style.display = 'none';
    errorElement.style.display = 'block';
    console.error(error);
  });
}, false);
