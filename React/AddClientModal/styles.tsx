/* eslint-disable @typescript-eslint/no-explicit-any */
import tw from 'tailwind-styled-components'

export const Container = tw.div`
  relative
  flex 
  flex-col 
  w-full
  md:w-[768px]
  min-h-[400px]
  max-h-[calc(100dvh-80px)]
  overflow-y-auto
  rounded-[12px]
  p-[32px]
  dark:text-primary-0
  text-light-primary-0 
  dark:bg-primary-80
  bg-light-primary-80
` as any
