import React from 'react';
import ReactDOM from 'react-dom';
import SearchForm from './components/searchForm';

const searchFormElement = <SearchForm />,
	searchFields = document.getElementsByClassName( 'search-form' );

if ( searchFields.length ) {

	for ( let i=0; i < searchFields.length; i++ ) {
		ReactDOM.render(
			searchFormElement,
			searchFields[ i ]
		)
	}
}

