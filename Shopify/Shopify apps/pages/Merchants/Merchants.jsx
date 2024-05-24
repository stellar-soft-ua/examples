import React, {useCallback, useEffect, useState} from "react";
import {fetchData} from "../utils/api.js";
import {Link} from "@shopify/polaris";
import {Navigate, useNavigate} from "react-router-dom";
import {useAuth} from "../utils/AuthContext.jsx";

export const Merchants = () => {
    const [merchants, setMerchants] = React.useState({});
    const [currentPage, setCurrentPage] = React.useState(1);
    useEffect(() => {
        const getMerchantsData = async () => {
            const data = await fetchData('/api/crm/merchants', { page: currentPage, perPage: 5 });
            setMerchants(data);
        };

        getMerchantsData();
    }, [currentPage]);
    const navigate = useNavigate();
    const { setIsAuthenticated } = useAuth();

    const { current_page, last_page } = merchants.meta || {};

    const onDownloadCsv = useCallback(async () => {
        try {
            const response = await fetchData('/api/crm/merchants/download?page=1&perPage=1000');
            const fileName = response.file;

            const fileUrl = `/admin-csv/${fileName}`;

            const link = document.createElement('a');
            link.href = fileUrl;
            link.setAttribute('download', fileName);
            document.body.appendChild(link);
            link.click();
            link.parentNode.removeChild(link);
        } catch (error) {
            console.error('Error with download file:', error);
        }
    }, []);


    const handlePageClick = (pageNumber) => {
        setCurrentPage(pageNumber);
    };

    const pageNumbers = [];
    for (let i = 1; i <= last_page; i++) {
        pageNumbers.push(i);
    }

    const handleLogout = () => {
        localStorage.removeItem('token');
        setIsAuthenticated(false);
        navigate('/admin/login');
    };
    console.log('merchants', merchants)
    return (
        <div>
            <div className="sidebar">
                <div>
                    <div onClick={handleLogout} className="sidebar__link">Logout</div>
                </div>
            </div>
            <div className="main-content">
                <h2 className="main-content__title">Merchants</h2>
                <div className="main-content__table">
                    <div className="main-content__tools">
                        <button className="main-content__button" onClick={onDownloadCsv}>Download CSV</button>
                        <input className="main-content__search" type="text" placeholder="Search for a Merchants"/>
                    </div>
                    <div className="table__container">
                        <table>
                            <thead className="table-header">
                            <tr>
                                <th className="table__columns">Store name</th>
                                <th className="table__columns">store email</th>
                                <th className="table__columns">State/Province</th>
                                <th className="table__columns">Store revenue</th>
                                <th className="table__columns">Plan</th>
                                <th className="table__columns">Subscription revenue</th>
                                <th className="table__columns">Month</th>
                                <th className="table__columns">orders</th>
                                <th className="table__columns">Active</th>
                            </tr>
                            </thead>
                            <tbody className="table-body" id="table-body">
                            {merchants.data && merchants.data.map((merchant, index) => {
                                return (
                                    <tr key={index}>
                                        <td className="table-rows">{merchant.name}</td>
                                        <td className="table-rows">{merchant.email}</td>
                                        <td className="table-rows">{merchant.state}</td>
                                        <td className="table-rows">{merchant.store_revenue}</td>
                                        <td className="table-rows">{merchant.plan}</td>
                                        <td className="table-rows">{merchant.subscription_revenue}</td>
                                        <td className="table-rows">{merchant.mount}</td>
                                        <td className="table-rows">{merchant.orders}</td>
                                        <td className={`table-rows ${merchant.is_active ? 'active' : ''}`}>
                                            {/*<p>{merchant.is_active ? 'Active' : 'Inactive'}</p>*/}
                                            <p>Active</p>
                                        </td>
                                    </tr>
                                )
                            })}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div className="main-content__table-footer">
                    <p className="main-content__table-footer__result">Showing <span
                        className="amount-per-page__minimum"> {merchants.meta?.from} </span> to
                        <span className="amount-per-page__maximum"> {merchants.meta?.to} </span> of
                        <span className="general-amount"> {merchants.meta?.total} </span> results
                    </p>
                    <div className="main-content__table-footer__pagination" id="pagination">
                        {current_page === 1 ? '' : <a href="#" onClick={() => handlePageClick(current_page - 1)} className="pagination__arrows">Previous</a>}

                        {pageNumbers.map(number => (
                            <a
                                key={number}
                                href="#"
                                onClick={() => handlePageClick(number)}
                                className={current_page === number ? 'active' : ''}
                            >
                                {number}
                            </a>
                        ))}
                        {current_page === last_page ? '' : <a href="#" onClick={() => handlePageClick(current_page + 1)} className="pagination__arrows">Next</a>}
                    </div>
                </div>
            </div>
        </div>
    )
}
