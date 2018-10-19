import React from 'react';
import SearchResult from './searchResult';

export default class SearchResults extends React.Component {

	constructor( props ) {
		super( props );
	}

	render() {

		let results      = '',
			resultsClass = '';

		// If the input is empty, like we deleted our query.
		if ( this.props.empty ) {
			return null;
		}

		if ( 0 < this.props.results.length || 0 < this.props.results.length && this.props.loading ) {

			// If we have results, OR we have results, but we're still typing. We don't want to take the results away to load more.
			const queryResults = this.props.results.map( result => {
				return(
					<SearchResult key={ result.id } result={ result } />
				);
			} );

			results      = <ul className="search-results-list">{ queryResults }</ul>;
			resultsClass = ' has-results performed-action';

		} else if ( this.props.loading ) {

			// If we're loading results for the first time.
			results      = <p>{ wds_react_post_search.loading_text }</p>;
			resultsClass = ' loading performed-action';

		} else if ( ! this.props.empty && this.props.lengthError ) {

			// If the input isn't empty but doesn't have enough characters.
			results      = <p>{ wds_react_post_search.length_error }</p>;
			resultsClass = ' character-length performed-action';

		} else if ( this.props.searched ) {

			// If no results were found.
			results      = <p>{ wds_react_post_search.no_results_text }</p>;
			resultsClass = ' no-results performed-action';

		}

		// Bail if we have no results variables set.
		if ( ! results ) {
			return null;
		}

		return (
			<div className={ `search-results-container${ resultsClass }` }>
				{ results }
			</div>
		)
	}
}
