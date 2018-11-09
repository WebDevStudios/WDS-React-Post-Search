import React from 'react';
import ReactDOM from 'react-dom';
import SearchForm from './components/searchForm';

const searchFields = document.getElementsByClassName( wds_react_post_search.search_form_class );

if ( searchFields.length ) {

	for ( let i = 0; i < searchFields.length; i++ ) {
		const searchForm = searchFields[ i ];
		let postType     = '';
		
		if( searchForm.querySelector('input[name=post_type]') ) {
			postType = searchForm.querySelector('input[name=post_type]').value;
		}

		ReactDOM.render(
			<SearchForm postType={ postType } />,
			searchFields[ i ]
		)
	}
}

