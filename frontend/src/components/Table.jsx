import { useState, useEffect, useMemo } from "react";
import {
  useReactTable,
  getCoreRowModel,
  getPaginationRowModel,
  flexRender,
} from "@tanstack/react-table";
import { fetchData, createData, updateData, deleteData } from "../api";
import Search from "./Search";
import { FiLogOut } from "react-icons/fi";
import { useNavigate } from "react-router-dom";
import { userLogout } from "../api";
function Table() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [searchFilters, setSearchFilters] = useState({
    geolat: "27.7012474",
    geolng: "85.3190894",
  });

  // Modal State
  const [showModal, setShowModal] = useState(false);
  const [modalType, setModalType] = useState(""); // "create" or "edit"
  const [modalData, setModalData] = useState({});
  const navigate = useNavigate();

  // Fetch data from API
  useEffect(() => {
    const loadData = async () => {
      setLoading(true);
      const result = await fetchData(searchFilters);
      setData(result);
      setLoading(false);
    };
    loadData();
  }, []);

  const handleSearchChange = (field, value) => {
    setSearchFilters((prev) => ({
      ...prev,
      [field]: value,
    }));
  };

  const handleClearFilters = () => {
    setSearchFilters({ name: "", email: "", geolat: "", geolng: "" });
  };

  const handleOpenModal = (type, rowData = {}) => {
    setModalType(type);
    setModalData(rowData);
    setShowModal(true);
  };

  const handleCloseModal = () => {
    setShowModal(false);
    setModalData({});
  };

  const handleSave = async () => {
    if (modalType === "create") {
      const newItem = await createData(modalData);
      setData((prev) => [...prev, newItem]);
    } else if (modalType === "edit") {
      await updateData(modalData.id, modalData);
      window.location.reload();
    }
    handleCloseModal();
  };

  const handleDelete = async (id) => {
    await deleteData(id);
    setData((prev) => prev.filter((item) => item.id !== id));
  };

  const handleLogout = async () => {
    await userLogout();
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    navigate("/");
  };

  const { name, email } = JSON.parse(localStorage.getItem("user"));
  // CURRENT USER or not from backend...(return true or false)
  // const isCurrUser = data[0].currentUser || true;
  const isCurrUser = false;

  const columns = useMemo(
    () => [
      {
        id: "sn",
        header: "S.N.",
        cell: (info) => info.row.index + 1,
      },
      // remove the the id from here and add S.N
      // {
      //   accessorKey: "id",
      //   header: "ID",
      // },
      {
        accessorKey: "name",
        header: "Name",
      },
      {
        accessorKey: "email",
        header: "Email",
      },
      {
        accessorKey: "full_address",
        header: "Full Address",
      },
      {
        accessorKey: "geolat",
        header: "Geo Latitude",
      },
      {
        accessorKey: "geolng",
        header: "Geo Longitude",
      },
      {
        accessorKey: "distance",
        header: "Distance",
      },
      {
        id: "actions",
        header: "Actions",
        cell: ({ row }) => (
          <div>
            <button
              onClick={() => handleOpenModal("edit", row.original)}
              disabled={isCurrUser}
            >
              Edit
            </button>
            <button
              onClick={() => handleDelete(row.original.id)}
              disabled={isCurrUser}
            >
              Delete
            </button>
          </div>
        ),
      },
    ],
    []
  );

  const table = useReactTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getRowId: (row, index) => index.toString(),
  });

  if (loading) return <div>Loading...</div>;

  return (
    <div className="root-table">
      <button className="logout-btn" onClick={handleLogout}>
        <FiLogOut />
      </button>
      <div className="user-info">
        <h2>Logged in as</h2>
        <p>Email: {email}</p>
        <p>Full Name: {name}</p>
      </div>
      <div>
        {/* grouping the search and modal in one div */}
        <div className="search-modal">
          <Search
            searchFilters={searchFilters}
            setData={setData}
            onSearchChange={handleSearchChange}
            onClearFilters={handleClearFilters}
          />
          {showModal && (
            <div className="modal">
              <div className="modal-content">
                <h2>
                  {modalType === "create" ? "Create New Item" : "Edit Item"}
                </h2>
                <div className="flex-col">
                  {/* <label>
                    Name: */}
                  <input
                    type="text"
                    value={modalData.name || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        name: e.target.value,
                      }))
                    }
                    placeholder="Full name"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="email"
                    value={modalData.email || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        email: e.target.value,
                      }))
                    }
                    placeholder="email"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="password"
                    value={modalData.password || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        password: e.target.value,
                      }))
                    }
                    placeholder="password"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="text"
                    value={modalData.city || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        city: e.target.value,
                      }))
                    }
                    placeholder="city"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="text"
                    value={modalData.state || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        state: e.target.value,
                      }))
                    }
                    placeholder="state"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="text"
                    value={modalData.zipcode || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        zipcode: e.target.value,
                      }))
                    }
                    placeholder="zipcode"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="number"
                    value={modalData.geolat || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        geolat: e.target.value,
                      }))
                    }
                    placeholder="Geo Lat"
                  />
                  {/* </label> */}
                </div>
                <div>
                  {/* <label>
                    Email: */}
                  <input
                    type="number"
                    value={modalData.geolng || ""}
                    onChange={(e) =>
                      setModalData((prev) => ({
                        ...prev,
                        geolng: e.target.value,
                      }))
                    }
                    placeholder="Geo Lng"
                  />
                  {/* </label> */}
                </div>
                <div>
                  <button onClick={handleSave} className="save">
                    Save
                  </button>
                  <button onClick={handleCloseModal} className="cancel">
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>
      <table>
        <thead>
          {table.getHeaderGroups().map((headerGroup) => (
            <tr key={headerGroup.id}>
              {headerGroup.headers.map((header) => (
                <th key={header.id}>
                  {header.isPlaceholder
                    ? null
                    : flexRender(
                        header.column.columnDef.header,
                        header.getContext()
                      )}
                </th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody>
          {table.getRowModel().rows.map((row, index) => (
            <tr key={row.id}>
              {row.getVisibleCells().map((cell) => (
                <td key={cell.id}>
                  {flexRender(cell.column.columnDef.cell, cell.getContext())}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
      <button className="add-new" onClick={() => handleOpenModal("create")}>
        Add New
      </button>
      <div className="next-prev">
        <button
          onClick={() => table.previousPage()}
          disabled={!table.getCanPreviousPage()}
          className="blue-button"
        >
          Previous
        </button>
        <span>
          Page {table.getState().pagination.pageIndex + 1} of{" "}
          {table.getPageCount()}
        </span>
        <button
          onClick={() => table.nextPage()}
          disabled={!table.getCanNextPage()}
          className="blue-button"
        >
          Next
        </button>
      </div>
    </div>
  );
}

export default Table;
