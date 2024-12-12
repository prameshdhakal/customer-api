import { fetchData } from "../api";

function Search({ searchFilters, onSearchChange, onClearFilters, setData }) {
  const handleInputChange = (field) => (e) => {
    onSearchChange(field, e.target.value);
  };

  return (
    <div className="filters">
      <div>
        <label>
          Geo Latitude:
          <input
            type="number"
            placeholder="Search by latitude"
            value={searchFilters.geolat}
            onChange={handleInputChange("geolat")}
          />
        </label>
      </div>
      <div>
        <label>
          Geo Longitude:
          <input
            type="number"
            placeholder="Search by longitude"
            value={searchFilters.geolng}
            onChange={handleInputChange("geolng")}
          />
        </label>
      </div>
      <div>
        <button onClick={onClearFilters}>Clear Filters</button>
        {/* on click will submit filters. */}
        <button
          onClick={async () => {
            console.log(await fetchData(searchFilters));
          }}
        >
          Sumbit
        </button>
      </div>
    </div>
  );
}

export default Search;
