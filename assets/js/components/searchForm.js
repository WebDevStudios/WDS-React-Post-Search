import React from 'react';
import qs from 'query-string';
import SearchResults from './searchResults';

export default class SearchForm extends React.Component {

	constructor( props ) {
		super( props );

		this.getResults   = this.getResults.bind( this );
		this.getFormClass = this.getFormClass.bind( this );

		this.state = {
			results: [],
			loading: false,
			searched: false,
			lengthError: false,
			empty: false,
		};
	}

	getResults( event ) {

		const search = event.target.value;

		if ( ! search ) {
			this.setState( {
				results: [],
				loading: false,
				searched: false,
				lengthError: false,
				empty: true,
			} );

			return;
		}

		if ( search && wds_react_post_search.minimum_character_count <= search.length ) {
			this.setState( {
				loading: true,
				searched: true,
				lengthError: false,
				empty: false,
			} );

			const postType = this.props.postType;

			let url   = wds_react_post_search.rest_search_posts.replace( '%s', search );
			let query = {
				s: search
			};

			if ( postType ) {
				query.type = postType;
			};

			const queryString = qs.stringify( query );
			url = `${ url }?${ queryString }`;
			
			let	json = fetch( url )
				.then(
					response => {
						return response.json()
					}
				)
				.then(
					results => {
						this.setState( {
							results: results,
							loading: false
						} );
					}
				);
		} else {
			this.setState( {
				results: [],
				searched: false,
				lengthError: true,
				empty: false,
			} );
		}
	}

	getFormClass() {
		let className = 'search-form-input';

		if ( this.state.results.length > 0 || this.state.loading || this.state.lengthError || this.state.searched ) {
			className += ' search-form-performing-action';
		}

		if ( this.state.empty ) {
			className = 'search-form-input';
		}

		console.log(className);

		return className;
	}
	
	render() {
		return (
			<div className={ `${ this.getFormClass() }` }>
				<input className="search-input" type="text" onKeyUp={ this.getResults } />
				<SearchResults searched={ this.state.searched } loading={ this.state.loading } results={ this.state.results } lengthError={ this.state.lengthError } empty={ this.state.empty } />
			</div>
		)
	}
}
