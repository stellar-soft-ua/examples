import { useEffect } from 'react'
import { fetchCurrencies } from '../../../../service/clients'
import { useAppDispatch, useAppSelector } from '../../../../store'

export const useCurrencies = () => {
  const dispatch = useAppDispatch()
  const currencies = useAppSelector((state) => state.clients.currencies)

  useEffect(() => {
    if (currencies) return
    dispatch(fetchCurrencies())
  }, [])

  return { currencies }
}
